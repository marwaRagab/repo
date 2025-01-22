function toggleInput(type) {
    // Get the input divs
    const barcodeInput = document.getElementById('barcodeInput');
    const serialInput = document.getElementById('serialInput');
    
    // Show/hide based on the selected type
    if (type === 'barcode') {
        barcodeInput.classList.remove('hidden');
        serialInput.classList.add('hidden');
    } else if (type === 'serial') {
        serialInput.classList.remove('hidden');
        barcodeInput.classList.add('hidden');
    }
}

// Optional: To hide both inputs on initial load
window.onload = function() {
    document.getElementById('barcodeInput').classList.add('hidden');
    document.getElementById('serialInput').classList.add('hidden');
};

function showInputs() {
    document.getElementById('additionalInputs').classList.remove('hidden');
}

function showInput() {
    document.getElementById('inputField').classList.remove('hidden');
}

function hideInput() {
    document.getElementById('inputField').classList.add('hidden');
}