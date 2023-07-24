function getBalance() {
  return 1000; // Just an example, it should retrieve data from a server
}

function deposit(amount) {
  console.log("Depositing:", amount);
}

function withdraw(amount) {
  console.log("Withdrawing:", amount);
}

function transfer(amount, recipient) {
  console.log("Transferring", amount, "to", recipient);
}

function payment(amount, recipient) {
  console.log("Paying", amount, "to", recipient);
}

function getTransactionHistory() {
  return ["Deposit: 500", "Withdraw: 200", "Payment: 300"]; // This is an example, should fetch data from a server
}

// Set up event listeners
document.getElementById('checkBalanceButton').addEventListener('click', function() {
  var balance = getBalance();
  document.getElementById('balanceDisplay').innerText = "Your balance is: $" + balance;
});

document.getElementById('depositButton').addEventListener('click', function() {
  var amount = document.getElementById('depositAmount').value;
  deposit(amount);
});

document.getElementById('withdrawButton').addEventListener('click', function() {
  var amount = document.getElementById('withdrawAmount').value;
  withdraw(amount);
});

document.getElementById('transferButton').addEventListener('click', function() {
  var amount = document.getElementById('transferAmount').value;
  var recipient = document.getElementById('transferRecipient').value;
  transfer(amount, recipient);
});

document.getElementById('paymentButton').addEventListener('click', function() {
  var amount = document.getElementById('paymentAmount').value;
  var recipient = document.getElementById('paymentRecipient').value;
  payment(amount, recipient);
});

document.getElementById('historyButton').addEventListener('click', function() {
  var history = getTransactionHistory();
  var historyList = document.getElementById('transactionHistory');
  historyList.innerHTML = '';
  history.forEach(function(transaction) {
    var listItem = document.createElement('li');
    listItem.innerText = transaction;
    historyList.appendChild(listItem);
  });
});