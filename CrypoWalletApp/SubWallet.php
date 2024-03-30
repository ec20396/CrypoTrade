<!DOCTYPE html>
<html>
<head>
    <title>Crypto Sub-Wallet</title>
    <?php include('head.php')?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php session_start(); ?>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#303030;">
            <?php include('nav.php')?>
        </nav>
    </div>



    <div class="individualSubwallet">
        <div id='subName'>[Insert Crypto] Wallet</div>
        <div id='subBalance'>Balance: [insert balance here]</div>
    
        <!-- Insert price chart here -->
        <div class="chart-container">
            <canvas id="myChart"></canvas>
            <a id= "seeMore" href="pricetracker.php">see more</a>
        </div>
    
        <div class = "buySellEchange">

            <!-- The Modal -->
            <div id="subWalletModal" class="modal">
                <!-- Modal content -->
                <div id = "subWalletModalContents" class="modal-content">
                    <h1 id="modalHeader">header</h1>
                    <form method="post" action="" id = "subwalletForm">
                        <div>
                            <br>
                            <label for="cryptoType2" id="cryptoType2Label" style="display: none;">Select currency to exchange to</label>
                            <select name="cryptoType2" id="cryptoType2" style="display: none;">
                                <option require>Select</option>
                                <option require>Bitcoin</option>
                                <option require>Ethereum</option>
                                <option require>XRP Ledger</option>
                                <option require>Binance Coin</option>
                                <option require>Yearn.finance</option>
                                <option require>Ethereum</option>
                                <option require>Litecoin</option>
                                <option require>Stellar Lumens</option>
                                <option require>Chainlink</option>
                                <option require>Polkadot</option>
                                <option require>EOSIO</option>
                            </select>
                            <br>
                            <label id="cryptoLabel" for="cryptoAmount">How much would you like to var</label>
                            <input type="num" id="cryptoAmount" name="cryptoAmount" placeholder="Amount" min=">0">
                        </div>
                        <input type="hidden" name="subWalletID" value="1" id="subWalletID">
                    </form>
                    <button id="confirm">Confirm</button>
                    <button id="cancel">Cancel</button>
                </div>
            </div>
            
            <div id='transactionButtons'>
                <button id="buy">Buy</button>
                <button id="sell">Sell</button>
                <button id="exchange">Exchange</button>
            </div>
        

        </div>
   
    <script src = "subWallet.js"></script>

</body>

</html


