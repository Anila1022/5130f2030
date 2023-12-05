<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html"); 
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Leasing vs. Buying</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url('car.jpg'); 
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .navbar, .login-signup-nav, .content, .login-signup-content {
            display: none;
            padding: 2em;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            margin: auto;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .navbar, .login-signup-nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 1em;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .navbar a, .login-signup-nav a {
            color: white;
            text-decoration: none;
            padding: 0.5em 1em;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .navbar a:hover, .login-signup-nav a:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        #mainContent {
            display: block;
        }



        input[type='text'], input[type='password'], input[type='number'], select, button {
            padding: 0.5em;
            margin: 0.5em 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: border-color 0.3s;
        }

        input[type='text']:focus, input[type='password']:focus, input[type='number']:focus, select:focus, button:focus {
            outline: none;
            border-color: #0056b3;
        }

        button {
            cursor: pointer;
            background-color: #0056b3;
            color: white;
        }

        button:hover {
            background-color: #003d82;
        }



        .result {
            margin-top: 1em;
            padding: 1em;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        
        .calculator-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            width: 40vw;
            max-width: 600px;
        }

        
        .calculator-container label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: bold;
        }

        .calculator-container input[type='number'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #333;
        }

        
        .calculator-container input[type='submit'] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .calculator-container input[type='submit']:hover {
            background-color: #0056b3;
        }

        #mainContent {
            display: flex;
            flex-direction: column;
            align-items: center; 
            text-align: center; 
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        #mainContent h1, #mainContent h2 {
            font-family: 'Arial', sans-serif;
            color: #333; 
        }

        #mainContent p {
            font-family: 'Arial', sans-serif;
            color: #555; 
        }
        
        #chartContainer {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            width: 40vw;
        }

        .login-signup-content {
            width: 300px;
            margin: 20px auto;
        }

        .login-signup-content h2 {
            text-align: center;
        }

        .login-signup-content form {
            display: flex;
            flex-direction: column;
        }

        .login-signup-content form input[type='submit'] {
            background-color: #0056b3;
            color: white;
            padding: 0.5em;
            border: none;
            border-radius: 5px;
            margin-top: 1em;
        }

        .login-signup-content form input[type='submit']:hover {
            background-color: #003d82;
        }

        .user-profile {
            position: relative;
          }

          .user-profile button {
            background-color: transparent;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
          }

          .user-profile button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
          }

          .profile-dropdown {
            display: none;
            position: absolute;
            top: 2em;
            right: 0;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 1; 
          }

          .profile-dropdown button {
            display: block;
            width: 100%;
            padding: 0.5em 1em;
            text-align: left;
            border: none;
            background-color: red;
            cursor: pointer;
          }

          .profile-dropdown button:hover {
            background-color: black;
            border-radius: 0;
          }

          .user-profile:hover .profile-dropdown {
            display: block;
          }

          table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #feedbackForm {
                margin: 20px;
                padding: 15px;
                background-color: #f8f8f8;
                border-radius: 5px;
            }

            #feedbackForm form {
                display: flex;
                flex-direction: column;
            }

            #feedbackForm label, #feedbackForm textarea, #feedbackForm input[type=submit] {
                margin-bottom: 10px;
            }


        
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
            <!-- User Profile Section -->
            <div class="user-profile">
                <button id="profileButton"><?= $_SESSION['username'] ?></button>
                <div class="profile-dropdown">
                    <button id="signOutButton">Sign Out</button>
                </div>
            </div>
        <?php endif; ?>

        <a href="javascript:void(0);" onclick="showSection('home')">Home</a>
        <a href="javascript:void(0);" onclick="showSection('leasing')">Leasing</a>
        <a href="javascript:void(0);" onclick="showSection('buying')">Buying</a>
        <a href="javascript:void(0);" onclick="showSection('details')">Details</a>
        <a href="javascript:void(0);" onclick="showSection('dealerships')">Dealerships</a>
        <a href="javascript:void(0);" onclick="showSection('calculator')">Calculator</a>
        <a href="javascript:void(0);" onclick="showSection('feedbackSection')">Feedback</a>
    </div>

    <!-- Main Content -->
    <div id="mainContent">
        <!-- Home Content -->
        <div class="content" id="home">
            <h1>Welcome to New Car Leasing vs Buying</h1>
            <th>Note::: This Site provides just an analysis of buying and leasing the vehical but not subjected to particular car . And the calculator is just fto know an overview of your financial things in order to purchase vehical. Please contact financial advisors before buying anything.</th>
            <p>Leasing and buying a car are two distinct approaches to acquiring a vehicle, each with its own set of advantages and disadvantages. Here's a comparison to help you understand the key differences.
                                Checkout the sections you needed!!!</p>
        </div>

        <!-- Leasing Content -->
        <div class="content" id="leasing">
            
            <h2>Leasing a Car</h2>
            <p>When you lease, you pay only for a portion of the vehicle's cost, which is the part that you "use up" during the time you're driving it.</p>

            

            
            <table>
                <tr>
                    <th>Advantages</th>
                    <th>Disadvantages</th>
                </tr>
                <tr>
                    <td>Lower Monthly Payments: Lease payments are generally lower than loan payments, allowing you to drive a more expensive car for less money per month.</td>
                    <td>Mileage Limits: Most leases come with mileage restrictions. Exceeding the limit can result in additional charges.</td>
                </tr>
                <tr>
                    <td>Newer Models: Leasing often allows you to drive a new car with the latest features and technology every few years.</td>
                    <td>No Ownership: At the end of the lease, you don't own the car. If you like having ownership or plan to keep the car for a long time, leasing may not be the best option.</td>
                </tr>
                <tr>
                    <td>Lower Repair Costs: Since leased vehicles are typically under warranty for the duration of the lease, major repair costs are often covered.</td>
                    <td>Customization Limits: Lease agreements often have restrictions on customizing or modifying the vehicle.</td>
                </tr>
                <tr>
                    <td>Flexibility: Leasing provides flexibility at the end of the term. You can choose to buy the vehicle, lease a new one, or explore other options.</td>
                    <td></td>
                </tr>
            </table>

            <h3>Benefits in Numbers</h3>
            <p>Discover the advantages of leasing through these compelling statistics:</p>


            <ul>
                <li>Percentage of people who choose leasing over buying: <strong>65%</strong></li>
                <li>Average monthly savings when leasing compared to buying: <strong>$150</strong></li>
                <li>Number of new car models available for lease each year: <strong>Over 500</strong></li>
                <li>Percentage of leased vehicles covered by comprehensive warranties: <strong>85%</strong></li>
                <li>Average down payment required for a car lease: <strong>$2,000</strong></li>
                <li>Number of miles included in a standard lease agreement: <strong>12,000 miles/year</strong></li>
                <li>Percentage of leased vehicles with zero or low initial capital cost: <strong>40%</strong></li>
                <li>Average lease term length: <strong>36 months</strong></li>
                <li>Percentage of lessees who choose to lease another vehicle after the term ends: <strong>70%</strong></li>
            </ul>

           
        

        </div>

        <!-- Buying Content -->
        <div class="content" id="buying">
            <h2>Buying a Car</h2>
            <p>Buying a car is a great option if you want full ownership of the vehicle and plan on keeping it for a long time.</p>

            
            <table>
                <tr>
                    <th>Advantages</th>
                    <th>Disadvantages</th>
                </tr>
                <tr>
                    <td>Ownership: You own the car outright after you've paid off the loan. This provides long-term value and the ability to keep the car for as long as you want.</td>
                    <td>Higher Monthly Payments: Monthly loan payments are typically higher than lease payments.</td>
                </tr>
                <tr>
                    <td>No Mileage Limits: You can drive as much as you want without worrying about mileage restrictions.</td>
                    <td>Depreciation: The value of a car depreciates over time. When you buy, you bear the full brunt of the depreciation, impacting the car's resale value.</td>
                </tr>
                <tr>
                    <td>Customization: You have the freedom to customize and modify the vehicle according to your preferences.</td>
                    <td>Maintenance Costs: As the car ages and goes out of warranty, you're responsible for maintenance and repair costs.</td>
                </tr>
                <tr>
                    <td>Build Equity: As you pay off the loan, you build equity in the vehicle. This equity can be used for a trade-in or down payment on your next car.</td>
                    <td>Commitment: Buying a car is a longer-term commitment. If you prefer driving a new car every few years, buying might not be the best fit.</td>
                </tr>
            </table>

            <h3>Benefits in Numbers</h3>
            <p>Explore the advantages of buying a car through these revealing statistics:</p>

            <ul>
                <li>Percentage of car owners who prefer buying over leasing: <strong>75%</strong></li>
                <li>Average vehicle ownership duration: <strong>7 years</strong></li>
                <li>Number of used cars available in the market for buyers: <strong>Millions</strong></li>
                <li>Percentage of car buyers who finance their purchase: <strong>70%</strong></li>
                <li>Average annual depreciation rate for new cars: <strong>15-20%</strong></li>
                <li>Number of car dealerships in the United States: <strong>Over 16,000</strong></li>
            </ul>


        </div>

        <!-- Details Content -->
        <div class="content" id="details">
            <h2>Details</h2>
            <p>More details about the benefits and costs of leasing versus buying a car over time.Click on the arrow below!!!</p>
            <details>
                <summary>Choosing Between Leasing and Buying:</summary>
                <ul>
                    <li><strong>Consider Your Driving Habits:</strong>
                        <ul>
                            <li>If you drive a lot of miles annually, buying may be a better option.</li>
                        </ul>
                    </li>
                    <li><strong>Evaluate Your Budget:</strong>
                        <ul>
                            <li>Consider your monthly budget and how it aligns with lease and loan payments.</li>
                        </ul>
                    </li>
                    <li><strong>Long-Term vs. Short-Term:</strong>
                        <ul>
                            <li>If you like driving a new car frequently, leasing might be preferable. If you prefer long-term ownership and building equity, buying is a better fit.</li>
                        </ul>
                    </li>
                    <li><strong>Factor in Customization:</strong>
                        <ul>
                            <li>If customizing the car is important to you, buying is the way to go.</li>
                        </ul>
                    </li>
                </ul>
                <p>Ultimately, the choice between leasing and buying depends on your individual preferences, financial situation, and how you plan to use the vehicle.</p>
            </details>
        </div>


        <!-- Dealerships Content -->
        <div class="content" id="dealerships">
            <h2>Car Dealerships</h2>
            <p>Find the perfect car at a dealership. Explore our recommended dealerships for the best car Buying  and Leasing experience.</p>


            
            <h3>Leasing Service Providers</h3>
            
                <li><a href="https://www.nissanusa.com/vehicles/crossovers-suvs/rogue/deals-incentives-offers.html?dcp=psr.58700008523721462&gad_source=1&gclid=Cj0KCQiAgqGrBhDtARIsAM5s0_ndQTTX_eBmcifVbR_7tSlf-emE2paZzLTqjXxmmyZ__7j_rKYAGREaAsv7EALw_wcB&gclsrc=aw.ds" target="_blank">Nissan Leasing Service</a></li>

                <li><a href="https://automobiles.honda.com/tools/current-offers" target="_blank">Honda Leasing Service</a></li>

                    <li><a href="https://www.newcars.com/secretprice/lease?gad_source=1&gclid=Cj0KCQiAgqGrBhDtARIsAM5s0_mqUNLBzhgKymeGwoxO77WeAVvzkZKeMBBS8dV99cNVwyD06Bb2wfAaAra2EALw_wcB" target="_blank">New cars Leasing Service</a></li>


            <h3>New cars Buying Service Providers</h3>
            
                <li><a href="https://www.nissanusa.com/shopping-tools/search-inventory" target="_blank">Nissan buying Service</a></li>

                <li><a href="https://www.commonwealthhonda.com/inventory/new" target="_blank">Honda buying Service</a></li>

                <li><a href="https://www.cars.com/new-cars/" target="_blank">New cars buying Service</a></li>

        </div>

        <!-- Calculator Content -->
        <div class="content" id="calculator">
          <h2>Car Cost Calculator</h2>
          <div class="calculator-container">
            <form id="calculatorForm">

              <label for="paymentType">Payment Type:</label>
                <select id="paymentType">
                    <option value="full">Full Payment</option>
                    <option value="loan">Loan</option>
                </select>

              <label for="bank">Select Bank:</label>
              <select id="bank" required>
              </select>
              <option value="" disabled selected>Select a bank</option>
              <label for="carPrice">Car Price:</label>
              <input type="number" id="carPrice" placeholder="Enter car price" required>

              <label for="downPayment">Down Payment:</label>
              <input type="number" id="downPayment" placeholder="Enter down payment" required>


              <label for="fullPayment">Full Payment (for buying):</label>
              <input type="number" id="fullPayment" placeholder="Enter full payment amount" required>

              <label for="leaseFinanceRate">Lease Finance Rate (%):</label>
              <input type="number" id="leaseFinanceRate" placeholder="Enter lease finance rate" step="0.1" required>

              <label for="interestRate">Interest Rate (%):</label>
              <input type="number" id="interestRateInput" placeholder="Enter interest rate" step="0.1" required>

              <label for="loanTerm">Loan Term (years):</label>
              <input type="number" id="loanTerm" placeholder="Enter loan term" required>

              <label for="leaseTerm">Lease Term (months):</label>
              <input type="number" id="leaseTerm" placeholder="Enter lease term" required>

              <label for="taxRate">Tax Rate (%):</label>
              <input type="number" id="taxRate" placeholder="Enter tax rate" step="0.1" required>

              <label for="insuranceCost">Insurance Cost (monthly):</label>
              <input type="number" id="insuranceCost" placeholder="Enter insurance cost" required>

              <input type="submit" value="Calculate">
            </form>
            <div id="chartContainer" style="position: relative; height:40vh; width:38vw">
              <canvas id="results"></canvas>

            </div>


          </div>


        </div>

        <div class="content" id="feedbackSection">
            <h2>Feedback</h2>
            <p>We value your feedback. Please let us know your thoughts and suggestions.</p>
            <form id="submitFeedback" method="post">
                <label for="feedback">Your Feedback:</label><br>
                <textarea id="feedback" name="feedback" rows="4" cols="50"></textarea><br>
                <input type="submit" value="Submit">
            </form>
            <div id="feedbackResponse"></div>
        </div>

        </div>



    <script>
        const bankSelect = document.getElementById("bank");
        const interestRateInput = document.getElementById("interestRateInput");
        const banks = [
            { name: "DCU", interestRate: Math.random() * (0.1 - 0.05) + 0.05 }, // takes random rate between 5% and 10%
            { name: "Chase", interestRate: Math.random() * (0.15 - 0.08) + 0.08 }, // takes random rate between 8% and 15%
            
        ];
        banks.forEach((bank) => {
            const option = document.createElement("option");
            option.value = bank.name;
            option.textContent = bank.name;
            bankSelect.appendChild(option);
        });
        bankSelect.addEventListener("change", function () {
            const selectedBank = banks.find((bank) => bank.name === bankSelect.value);

            if (selectedBank) {
                interestRateInput.value = selectedBank.interestRate.toFixed(2); 
            } else {
                interestRateInput.value = ""; 
            }
        });


        window.onload = function () {
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                mainContent.scrollIntoView({ behavior: 'smooth' });
            }
        };
        
        var users = {};

        
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('content');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            var activeSection = document.getElementById(sectionId);
            if (activeSection) {
                activeSection.style.display = 'block';
            }
        }

        
        showSection('home');

        var profileButton = document.getElementById('profileButton');
        var profileDropdown = document.querySelector('.profile-dropdown');

        profileButton.addEventListener('click', function () {
            profileDropdown.classList.toggle('show');
        });

        
        var signOutButton = document.getElementById('signOutButton');
        signOutButton.addEventListener('click', function () {
            
            fetch('update_session.php', {
                method: 'POST',
                body: 'setLoggedIn=false',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.text())
            .then(data => {
                
                console.log(data); 
                // Redirect to the login page and close the session
                window.location.href = 'index.html';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        document.getElementById('calculatorForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Retrieve input values from form
            var carPrice = parseFloat(document.getElementById('carPrice').value);
            var downPayment = parseFloat(document.getElementById('downPayment').value);
            var fullPayment = parseFloat(document.getElementById('fullPayment').value);
            var leaseFinanceRate = parseFloat(document.getElementById('leaseFinanceRate').value) / 100;
            var interestRate = parseFloat(banks.find((bank) => bank.name === document.getElementById("bank").value).interestRate);
            var loanTerm = parseInt(document.getElementById('loanTerm').value);
            var leaseTerm = parseInt(document.getElementById('leaseTerm').value);
            var insuranceCost = parseFloat(document.getElementById('insuranceCost').value);

            // New calculations
            var totalFullPaymentCost = calculateFullPaymentCost(fullPayment, insuranceCost, loanTerm);
            var totalLeaseFinanceCost = calculateLeaseFinancePayment(carPrice, downPayment, leaseTerm, leaseFinanceRate, insuranceCost);
            var monthlyLoanPayment = calculateLoanPayment(carPrice, downPayment, interestRate, loanTerm);
            var totalLoanCost = (monthlyLoanPayment * loanTerm * 12) + downPayment;
            var monthlyLeasePayment = calculateLeasePayment(carPrice, downPayment, leaseTerm);
            var totalLeaseCost = (monthlyLeasePayment * leaseTerm) + downPayment;

            console.log("Total Loan Cost:", totalLoanCost);
            console.log("Total Lease Cost:", totalLeaseCost);
            console.log("Total Full Payment Cost:", totalFullPaymentCost);
            console.log("Total Lease Finance Cost:", totalLeaseFinanceCost);

            // Update the chart
            updateChart(totalLoanCost, totalLeaseCost, totalFullPaymentCost, totalLeaseFinanceCost);
        });


        document.getElementById('paymentType').addEventListener('change', function () {
            var paymentType = this.value;
            if (paymentType === 'full') {
                
                document.getElementById('downPayment').disabled = true;
                document.getElementById('interestRateInput').disabled = true;
                document.getElementById('loanTerm').disabled = true;
                document.getElementById('leaseTerm').disabled = true;
                document.getElementById('leaseFinanceRate').disabled = true;

                
                document.getElementById('fullPayment').disabled = false;
            } else if (paymentType === 'loan' || paymentType === 'lease') {
                // Enable loan-related fields
                document.getElementById('downPayment').disabled = false;
                document.getElementById('interestRateInput').disabled = false;
                document.getElementById('loanTerm').disabled = false;
                document.getElementById('leaseTerm').disabled = false;
                document.getElementById('leaseFinanceRate').disabled = false;

                
                document.getElementById('fullPayment').disabled = true;
            }
        });


        document.getElementById("submitFeedback").addEventListener("submit", function(event){
            event.preventDefault();
            var feedback = document.getElementById("feedback").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_feedback.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById("feedbackResponse").innerHTML = "Feedback submitted successfully";
                    document.getElementById("feedback").value = ""; // Reset textarea
                }
            }
            xhr.send("feedback=" + feedback);
        });


        


        function calculateFullPaymentCost(fullPayment, insuranceCost, term) {
            var totalInsuranceCost = insuranceCost * term * 12;
            return fullPayment + totalInsuranceCost;
        }

        function calculateLoanPayment(carPrice, downPayment, interestRate, loanTerm) {
            var principal = carPrice - downPayment;
            var monthlyInterestRate = interestRate / 12;
            var numberOfPayments = loanTerm * 12;
            var compoundedInterestRate = Math.pow(1 + monthlyInterestRate, numberOfPayments);
            var interestQuotient = (monthlyInterestRate * compoundedInterestRate) / (compoundedInterestRate - 1);
            var monthlyPayment = principal * interestQuotient;
            return monthlyPayment;
        }

        function calculateLeasePayment(carPrice, downPayment, leaseTerm) {
            // Simplified lease payment calculation
            var monthlyPayment = (carPrice - downPayment) / leaseTerm;
            return monthlyPayment;
        }
        function calculateLeaseFinancePayment(carPrice, downPayment, term, financeRate, insuranceCost) {
            var monthlyPayment = calculateLeasePayment(carPrice, downPayment, term); // Use existing function
            var financeCost = monthlyPayment * term * financeRate;
            var totalInsuranceCost = insuranceCost * term;
            return (monthlyPayment * term) + financeCost + totalInsuranceCost;
        }

        
        // Create a Chart.js bar chart to compare total costs
        var ctx = document.getElementById('results').getContext('2d');
        var costComparisonChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Loan', 'Lease'],
                datasets: [{
                    label: 'Total Cost of Ownership',
                    data: [0, 0], // Placeholder data
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cost in USD'
                        }
                    }
                }
            }
        });

        costComparisonChart.data.labels = ['Loan', 'Lease', 'Full Payment', 'Lease with Finance'];
        costComparisonChart.data.datasets[0].data = [0, 0, 0, 0]; // Placeholder data for four scenarios

        function updateChart(loanCost, leaseCost, fullPaymentCost, leaseFinanceCost) {
            costComparisonChart.data.datasets[0].data[0] = loanCost;
            costComparisonChart.data.datasets[0].data[1] = leaseCost;
            costComparisonChart.data.datasets[0].data[2] = fullPaymentCost;
            costComparisonChart.data.datasets[0].data[3] = leaseFinanceCost;
            costComparisonChart.update();
        }

        





    </script>
</body>
</html>

