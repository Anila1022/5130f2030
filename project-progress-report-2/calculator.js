function calculateLease() {
    let amount = parseFloat(document.getElementById('leaseAmount').value);
    let duration = parseFloat(document.getElementById('leaseDuration').value);
    let result = amount / duration;
    document.getElementById('leaseResults').innerHTML = `Monthly lease payment: $${result.toFixed(2)}`;
}

function calculateBuy() {
    let amount = parseFloat(document.getElementById('buyingAmount').value);
    let financeOption = document.getElementById('financeOptions').value;
    
    let result;
    switch (financeOption) {
        case "DCU":
            result = amount / 60;  // Example formula
            break;
        case "Chase":
            result = amount / 48;  // Example formula
            break;
        case "Zolve":
            result = amount / 36;  // Example formula
            break;
        default:
            result = 0;
    }
    
    document.getElementById('buyResults').innerHTML = `Monthly payment: $${result.toFixed(2)}`;
}
