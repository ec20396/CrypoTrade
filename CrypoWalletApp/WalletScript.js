let subwalletTableCells = Array.from(
    document.querySelector('table').querySelectorAll('td')
);

const priceChanges = subwalletTableCells.filter((td, i) => i % 3 === 3 - 1);
let changesIndexList = priceChanges.map(change => subwalletTableCells.indexOf(change));

findNearestPriceChangeIndex = (hoverIndex) => {
    let nearestPriceChangeIndex = 0;

    for (let i = 0; i < changesIndexList.length; i++){
        if ((hoverIndex <= changesIndexList[i]) && (hoverIndex > changesIndexList[i - 1])){
            nearestPriceChangeIndex = i;
            if (changesIndexList[i] != 0){
                nearestPriceChangeIndex = i;
            }
            else{
                if (changesIndexList.includes(changesIndexList[i])){
                    nearestPriceChangeIndex = changesIndexList[i];
                }
            }
        }
    }
    return nearestPriceChangeIndex;
}

const currenciesShorthandToDisplay = new Map([
    ['btc', 'Bitcoin'], ['eth', 'Ethereum'], ['ltc', 'Litecoin'], ['bnb', 'Binance Coin'], ['eos', 'EOSIO'],
    ['xrp', 'XRP Ledger'], ['xlm', 'Stellar Lumens'], ['link', 'Chainlink'], ['dot', 'Polkadot'], ['yfi', 'Yearn.finance']
]);
const currenciesShorthandToURL = new Map([
    ['btc', 'bitcoin'], ['eth', 'ethereum'], ['ltc', 'litecoin'], ['bnb', 'binancecoin'], ['eos', 'eos'],
    ['xrp', 'ripple'], ['xlm', 'stellar'], ['link', 'chainlink'], ['dot', 'polkadot'], ['yfi', 'yearn-finance']
]);

function getCurrencyNameAsForm(currency, form){
    let currencyName = '';
    if(Array.from(currenciesShorthandToDisplay.keys()).includes(currency) && form === 'display'){
        currencyName = currenciesShorthandToDisplay.get(currency);
    }
    else if(Array.from(currenciesShorthandToDisplay.values()).includes(currency) && form === 'URL'){
        currencyName = Array.from(currenciesShorthandToURL.values())[
            Array.from(currenciesShorthandToDisplay.values()).indexOf(currency)
        ];
    }
    return currencyName;
}

const coins = Array.from(document.querySelector('table').querySelectorAll('a'));
coins.forEach(async coin => {
    let coinName = coin.innerHTML.trim();
    let coinFormatted = getCurrencyNameAsForm(coinName, 'URL');
    const response = await fetch('https://api.coingecko.com/api/v3/coins/'+coinFormatted+'?tickers=true&market_data=true&community_data=true&developer_data=false&sparkline=true');
    const assetData = await response.json();
    let priceChangePercentage = assetData['market_data']['price_change_percentage_24h'];
    priceChangePercentage = priceChangePercentage.toFixed(2);
    if (!String(priceChangePercentage).includes('-')){
        priceChangePercentage = '+ ' + priceChangePercentage;
    }
    else{
        String(priceChangePercentage);
        priceChangePercentage = '- ' + priceChangePercentage.slice(1, priceChangePercentage.length);
    }
    let aArray = subwalletTableCells.map(cell => cell.innerHTML.trim()).filter((td, i) => i % 3 === 0);
    let coinsFromLinks = aArray.map(link => link.split(/\s+/)[2]);
    if (coinName.includes(' ')){
        let coinFullName = new Map([
            ['Binance', 'Binance Coin'], ['XRP', 'XRP Ledger'], ['Stellar', 'Stellar Lumens']
        ]);
        let coinFirst = coinName.split(' ')[0];
        coinsFromLinks[coinsFromLinks.indexOf(coinFirst)] = coinFullName.get(coinFirst);
    }
    let tableCellIndex = subwalletTableCells.map(
        tableCell => tableCell.innerHTML.trim()
    ).indexOf(aArray[coinsFromLinks.indexOf(coinName)]);
    priceChanges[findNearestPriceChangeIndex(tableCellIndex)].innerHTML = priceChangePercentage + '%';
    colourCodePriceChange(priceChanges[findNearestPriceChangeIndex(tableCellIndex)]);
});

subwalletTableCells.forEach(data => data.addEventListener('mouseover', function(){
    let hoverIndex = subwalletTableCells.indexOf(data);
    let rowPriceChange = findNearestPriceChangeIndex(hoverIndex);
    priceChanges[rowPriceChange].style.color = 'white';
}));

subwalletTableCells.forEach(cell => cell.addEventListener('mouseout', function(){
    let lastCell = subwalletTableCells.indexOf(cell);
    colourCodePriceChange(priceChanges[findNearestPriceChangeIndex(lastCell)]);
}));

function colourCodePriceChange(change){
    if (change.innerHTML.split(/\s+/)[0] == "+"){
        change.style.color = 'rgb(94, 213, 155)';
    }
    else{
        change.style.color = 'red';
    }
}

async function getSupportedCurrencies(){
    let currencies = [];
    const responseSupported = await fetch('https://api.coingecko.com/api/v3/simple/supported_vs_currencies');
    const supportedAssets = await responseSupported.json();
    return supportedAssets;
}

let currencyOptions = document.getElementById('assetsChoices').innerHTML;

const assets = Array.from(document.querySelector('table').querySelectorAll('a'));
assets.forEach(asset => {
	asset.addEventListener('click', function(){
		asset.href += '?RequestedAsset=' + asset.innerHTML.trim();
	});
});

const addSubwalletButton = document.getElementById('addSubwalletButton');
const modalAdd = document.getElementsByClassName('modalAdd')[0];
const addSubwalletPopup = modalAdd.getElementsByClassName('addSubwalletPopup')[0];

const removeSubwalletButton = document.getElementById('removeSubwalletButton');
const modalRemove = document.getElementsByClassName('modalRemove')[0];
const removeSubwalletPopup = modalRemove.getElementsByClassName('removeSubwalletPopup')[0];

// Add event listeners to the buttons to show the modal when clicked
addSubwalletButton.addEventListener('click', async () => {
    modalAdd.style.display = 'block';
    addSubwalletPopup.style.display = 'block';
    let currencies = Array.from(await getSupportedCurrencies());
    currencies = currencies.filter(currency => Array.from(
        currenciesShorthandToDisplay.keys()).includes(currency)
    ).map(currency => getCurrencyNameAsForm(currency, 'display'));
    currencies.forEach(currency => {
        currencyOptions += '<option>';
        currencyOptions += currency;
        currencyOptions += '</option>';
    });
    document.getElementById('assetsChoices').innerHTML = currencyOptions;
});

let addSubwalletConfirm = document.getElementById('addConfirmButton');

document.getElementById('assetsChoices').addEventListener('change', function(){
    if (assets.map(
        asset => asset.innerHTML.trim()).includes(
            document.getElementById('assetsChoices').value
        )
    ){
        window.alert('This subwallet already exists');
        document.getElementById('assetsChoices').value = 'Select';
    }
});

addSubwalletConfirm.addEventListener('click', function(){
    if (document.getElementById('assetsChoices').value != 'Select'){
        modalAdd.style.display = 'none';
    }
    else{
        window.alert('No asset has been selected');
    }
});

document.getElementById('addCancelButton').addEventListener('click', function(){
    modalAdd.style.display = 'none';
});

removeSubwalletButton.addEventListener('click', function(){
    modalRemove.style.display = 'block';
    removeSubwalletPopup.style.display = 'block';
});

let removeConfirmButton = document.getElementById('removeConfirmButton');
removeConfirmButton.addEventListener('click', function(){
    if (assets.map(
        asset => asset.innerHTML.trim()).includes(
            document.getElementById('currencyName').value
        )
    ){
        let windowConfirm = window.confirm('Are you sure you wish to remove this subwallet?');

        if (windowConfirm) {
            modalRemove.style.display = 'none';
        }
    }
    else if(document.getElementById('currencyName').value === ''){
        window.alert('No asset has been selected');
    }
    else{
        window.alert('You do not have this subwallet');
    }
});

document.getElementById('removeCancelButton').addEventListener('click', function(){
    modalRemove.style.display = 'none';
});