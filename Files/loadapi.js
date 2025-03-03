// Load Telegram API
var tgapi = document.createElement('script');
tgapi.src = "https://telegram.org/js/telegram-web-app.js";

tgapi.onload = function() {
	console.log('Telegram API loaded');
	globalThis.tg = window.Telegram.WebApp;
	console.log('Telegram object:', window.Telegram);
	tg.expand();

	const { id, username } = tg.initDataUnsafe.user;

	globalThis.tg_userID = id;
	globalThis.tg_userName = username;

	console.log('Telegram initialized. User ID:', tg_userID, 'Username:', tg_userName);
};
document.head.appendChild(tgapi);

// TonConnect
var tonConnect = document.createElement('script');
tonConnect.src = "https://unpkg.com/@tonconnect/ui@latest/dist/tonconnect-ui.min.js";
tonConnect.onload = function() {
    console.log('TonConnect loaded');
};
document.head.appendChild(tonConnect);

// Adsgram
var adsgram = document.createElement('script');
adsgram.src = "https://sad.adsgram.ai/js/sad.min.js";
adsgram.onload = function() {
    console.log('Adsgram loaded');
	globalThis.AdController = window.Adsgram.init({ blockId: "0000" }); // Replace zeroes with your ad block ID
};
document.head.appendChild(adsgram);