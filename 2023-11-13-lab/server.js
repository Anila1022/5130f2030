const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const nodemailer = require('nodemailer'); 
const axios = require('axios');
const app = express();
const port = 3000;

app.use(bodyParser.json());

// Dummy database for user profiles
const users = [];

// Nodemailer transporter setup 
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'your_email@gmail.com',
        pass: 'your_email_password',
    },
});

app.use(express.static(path.join(__dirname, '/')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

// Sign-up endpoint
app.post('/signup', (req, res) => {
    const { email, password } = req.body;

    // Add basic validation 
    if (!email || !password) {
        return res.status(400).json({ error: 'Email and password are required' });
    }

    // Add the user to the database 
    const verificationToken = generateVerificationToken(); // Function to generate a unique token
    users.push({ email, password, verified: false, verificationToken });

    // Send verification email
    sendVerificationEmail(email, verificationToken);

    res.status(200).json({ message: 'Signup successful. Verification email sent.' });
});

// Login endpoint
app.post('/login', (req, res) => {
    const { email, password } = req.body;

    // Find the user in the database 
    const user = users.find(u => u.email === email && u.password === password);

    if (!user) {
        return res.status(401).json({ error: 'Invalid credentials' });
    }

    if (!user.verified) {
        return res.status(401).json({ error: 'Email not verified. Please check your email for the verification link.' });
    }

    res.status(200).json({ message: 'Login successful' });
});

// Verification endpoint
app.get('/verify', (req, res) => {
    const token = req.query.token;
    const user = users.find(u => u.verificationToken === token);

    if (!user) {
        return res.status(404).json({ error: 'Invalid verification token' });
    }

    // Mark the user as verified (you should update the database in a real application)
    user.verified = true;

    res.status(200).sendFile(path.join(__dirname, 'verification-success.html'));
});

app.get('/getWeather', async (req, res) => {
    const { latitude, longitude } = req.query;

    try {
        const weatherResponse = await axios.get(
            `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=YOUR_OPENWEATHERMAP_API_KEY`
        );

        const weatherData = weatherResponse.data;
        res.status(200).json(weatherData);
    } catch (error) {
        console.error(`Error getting weather data: ${error.message}`);
        res.status(500).json({ error: 'Error getting weather data' });
    }
});

// Helper function to generate a unique verification token
function generateVerificationToken() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}

// Helper function to send a verification email
function sendVerificationEmail(email, verificationToken) {
    const mailOptions = {
        from: 'your_email@gmail.com',
        to: email,
        subject: 'Verify Your Email',
        text: `Click the following link to verify your email: http://localhost:3000/verify?token=${verificationToken}`,
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.error(error);
        } else {
            console.log('Email sent: ' + info.response);
        }
    });
}

app.listen(port, () => {
    console.log(`Server is running at http://localhost:${port}`);
});
