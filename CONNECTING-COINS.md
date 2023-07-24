Download Bitcoin core from official https://bitcoin.org/en/bitcoin-core/

after instlation run your bitcoind 

bitcoind & 

it will create new directiry in root .bitcoind 

cd ~/.bitcoind/
 then create bitcoin.conf

nano bitcoin.conf


** Add config to bitcoin.conf file ** 

rpcuser=nodeuser
rpcpassword=nodepassword
testnet=1
rpcport=8332
rpcallowip=127.0.0.1
server=1


and restart bitcoind 


test with curl 



curl --user nodeuser:nodepassword --data-binary '{"jsonrpc": "1.0", "id":"curltest", "method": "getnewaddress", "params": [] }' -H 'content-type: text/plain;' http://127.0.0.1:8332/ -w '%{http_code}\n'
if it works changes rpcuser and rpcpassword in .env file for bitcoin 

















You have to add Bitcoin personal Package Archive (PPA) 

sudo apt-add-repository ppa:bitcoin/bitcoin

Note: Personal Package Archive (PPA) are software repositories designed for Ubuntu users. PPA is like a play store for Android users. All the software that are verified and allowed to install is available in PPA.

Adding the repository needs user authentication, so you might be asked to provide a password to authenticate the request. You will be prompted on the terminal to press enter, just press enter.

Use the below command to get the updates to the Bitcoin repository just added.

sudo apt-get update

You can install BTC full node with the combination of GUl ( Graphical user interface ) or terminal or both. 

sudo apt-get install bitcoin-qt → Use this for the full node with only GUI 

sudo apt-get install bitcoind → Use this for the full node with only Terminal sudo apt-get install bitcoin-qt bitcoind → Use this for the full node with both GUI & Terminal  

Please use the installation with the terminal option to follow the rest of the article as I have used terminal commands for illustration throughout this article. 

After the successful installation, you will see all the bitcoin files on the lib directory. Running the Bitcoin node:  Use bitcoind to run the Bitcoin node. 

To check available options type bitcoind --help on the terminal.

It is advised to add the config file in the path  ~/.bitcoin/bitcoin.conf

Testnet sample code for the config file is

#server=1  // enable this for main net and commant testnet

testnet=1   // un commant this to run the node on test net and commant server

deamon=1 // this is used to run the node in background

#rpcbind=0.0.0.0:18332 

rpcuser=username

rpcpassword=Password

rpcallowip=0.0.0.0/0

rpcallowip=custom ip address

#rpcport=54543

walletnotify=/home/transaction.sh %s 

You should specify configuration params in a config file, like the node is a test/main net, setting the password and username, IP to access the wallet, etc

walletnotify option is used to receive the information when there is a change in the wallet, like a new deposit to the wallet. It returns the transaction in key %s. 

transaction.sh file is a custom file which written to save the Id’s, as below 

#!/bin/sh

echo $1 >> ~/tran.txt

tran.txt will have the transaction Id’s affected the wallet. 

You have to synchronize your node with all the transactions and blocks before starting to use it. This might take days depending on the size of data to be synchronized.

After the full synchronization, you are ready for the actual process of node wallet i.e validating the blocks, depositing and withdrawal process. 

You can access the wallet within the server itself using the bitcoin-cli. You can use this option for quick verification of successful node installation.

For example, to get the balance type bitcoin-cli getbalance it returns the balance of the wallet. 


You can use bitcoin-cli commands to get a list of transactions, transaction etc on the Bitcoin node. 


