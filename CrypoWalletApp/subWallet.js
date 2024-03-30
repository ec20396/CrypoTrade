
// Get the modal element and buttons
var modal = document.getElementById('subWalletModal');
var buyButton = document.getElementById('buy');
var sellButton = document.getElementById('sell');
var exchangeButton = document.getElementById('exchange');
var modalHeader = document.getElementById("modalHeader");
var confirmButton = document.getElementById('confirm');
var cancelButton = document.getElementById('cancel');
var subwalletForm = document.getElementById('subwalletForm');
var subWalletName = document.getElementById('subName');

const currenciesShorthandToDisplay = new Map([
    ['btc', 'Bitcoin'], ['eth', 'Ethereum'], ['ltc', 'Litecoin'], ['bch', 'Bitcoin Cash'], ['bnb', 'Binance Coin'], ['eos', 'EOSIO'],
    ['xrp', 'XRP Ledger'], ['xlm', 'Stellar Lumens'], ['link', 'Chainlink'], ['dot', 'Polkadot'], ['yfi', 'Yearn.finance']
]);
const currenciesShorthandToURL = new Map([
    ['btc', 'bitcoin'], ['eth', 'ethereum'], ['ltc', 'litecoin'], ['bch', 'bitcoin-cash'], ['bnb', 'binancecoin'], ['eos', 'eos'],
    ['xrp', 'ripple'], ['xlm', 'stellar'], ['link', 'chainlink'], ['dot', 'polkadot'], ['yfi', 'yearn-finance']
]);

// Add event listeners to the buttons to show the modal when clicked
buyButton.addEventListener('click', async function() {
    modalHeader.innerHTML = "Buy";
    updateLabel('Buy');
    addCurrencyDropDown();
    subwalletForm.action = 'buy.php';
    modal.style.display = 'block';
});

sellButton.addEventListener('click', async function() {
    modalHeader.innerHTML = "Sell";
    updateLabel('Sell');
    addCurrencyDropDown();
    subwalletForm.action = 'sell.php';
    modal.style.display = 'block';
});

exchangeButton.addEventListener('click', async function(){
    document.getElementById('cryptoType2Label').style.display = 'inline';
    document.getElementById('cryptoType2').style.display = 'inline';
    modalHeader.innerHTML = "Exchange";
    updateLabel('Exchange');
    addCurrencyDropDown();
    subwalletForm.action = 'exchange.php';
    modal.style.display = 'block';
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
        modal.style.display = 'none';
        document.getElementById('cryptoType2Label').style.display = 'none';
        document.getElementById('cryptoType2').style.display = 'none';
}
}

function updateLabel(option) {
    const label = document.getElementById('cryptoLabel');
    label.textContent = `How much would you like to ${option}`;
    document.getElementById('subwalletForm').action = 'buy.php';
}

function submitForm() {
    const cryptoType = document.getElementById('cryptoType').value;
    const cryptoAmount = document.getElementById('cryptoAmount').value;
    
    if (!cryptoType || !cryptoAmount) {
        alert('Please fill out all required fields.');
        return;
    }

    if (isNaN(parseFloat(cryptoAmount))) {
        alert('Please enter a valid number for the amount.');
        return;
    }
    document.querySelector('form').submit();
    alert('Your transaction has been submitted.')
}

confirmButton.addEventListener('click', submitForm);

function resetForm() {
    document.getElementById('cryptoType').selectedIndex = 0;
    document.getElementById('cryptoAmount').value = '';
}

function closeSubWalletModal() {
    document.getElementById('subWalletModal').style.display = 'none';
    resetForm();
}

cancelButton.addEventListener('click', closeSubWalletModal);

let cryptoDropdown = document.getElementById('cryptoType2'); 
cryptoDropdown.addEventListener('change', function(){
    if (urlParams.get('RequestedAsset') == cryptoDropdown.value){
        window.alert('You can not choose the same subwallet');
        cryptoDropdown.value = 'Select';
    }
});

async function getData(crypto) {
    const endDate = new Date();
    const startDate = new Date();
    startDate.setFullYear(startDate.getFullYear() - 1);
    const startTimestamp = Math.floor(startDate.getTime() / 1000);
    const endTimestamp = Math.floor(endDate.getTime() / 1000);
    const response = await fetch(`https://api.coingecko.com/api/v3/coins/${crypto}/market_chart/range?vs_currency=usd&from=${startTimestamp}&to=${endTimestamp}`);
    const data = await response.json();
    const prices = data.prices.map(price => price[1]);
    return prices;
}

async function createChart(crypto) {
    const prices = await getData(crypto);
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: getPast12Months(),
            datasets: [{
                label: `${crypto} Price`,
                data: prices,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function getPast12Months() {
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    const today = new Date();
    const currentMonth = today.getMonth();
    const past12Months = [];
    for (let i = 11; i >= 0; i--) {
        const monthIndex = (currentMonth - i + 12) % 12;
        past12Months.push(monthNames[monthIndex]);
    }
    return past12Months;
}
// Get the crypto query parameter from the URL
const urlParams = new URLSearchParams(window.location.search);
const crypto = urlParams.get('RequestedAsset');
subWalletName.innerHTML = crypto + " Sub-Wallet";
// Call the createChart function with the crypto query parameter
var cryptoInternal = crypto.toLowerCase();
createChart(cryptoInternal);

let currencyOptions = document.getElementById('cryptoType').innerHTML;
let currencyOptions2 = document.getElementById('cryptoType2').innerHTML;
let currencyOptions3 = document.getElementById('cryptoType3').innerHTML;
//API call to get currencies
async function getSupportedCurrencies(){
    let currencies = [];
    const responseSupported = await fetch('https://api.coingecko.com/api/v3/simple/supported_vs_currencies');
    const supportedAssets = await responseSupported.json();
    console.log('\n\ncurrencies ' + supportedAssets);
    return supportedAssets;
}

async function addCurrencyDropDown(){
    let currencies = Array.from(await getSupportedCurrencies());
    currencies = currencies.filter(currency => Array.from(
        currenciesShorthandToDisplay.keys()).includes(currency)
        ).map(currency => getCurrencyNameAsForm(currency, 'display'));

    currencies.forEach(currency => {
        console.log('currency ' + currency);
        currencyOptions += '<option>';
        currencyOptions += currency;
        currencyOptions += '</option>';
    });
    document.getElementById('cryptoType').innerHTML = currencyOptions;
    document.getElementById('cryptoType2').innerHTML = currencyOptions;
    document.getElementById('cryptoType3').innerHTML = currencyOptions;
}

function getCurrencyNameAsForm(currency, form){
    let currencyName = '';
    if(Array.from(currenciesShorthandToDisplay.keys()).includes(currency) && form === 'display'){
        currencyName = currenciesShorthandToDisplay.get(currency);
        console.log('if');
    }
    else if(Array.from(currenciesShorthandToDisplay.values()).includes(currency) && form === 'URL'){
        currencyName = Array.from(currenciesShorthandToURL.values())[
            Array.from(currenciesShorthandToDisplay.values()).indexOf(currency)
        ];
        console.log('else if');
    }
    console.log('currencyName ' + currencyName);
    return currencyName;
}


