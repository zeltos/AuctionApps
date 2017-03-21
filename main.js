const applicationServerPublicKey = 'BASvQhtlUN5h-LeiKVabTZKsVo7FOwy0arPl2Gk9TdMAjjZCnStWQ_DbZCipX81TCCKbTzvEMRAqpgWT7Op4hQQ';
// function updateBtn() {
//   if (isSubscribed) {
//     pushButton.textContent = 'Disable Push Messaging';
//   } else {
//     pushButton.textContent = 'Enable Push Messaging';
//   }
//
//   pushButton.disabled = false;
// }
function initialiseUI() {
  // Set the initial subscription value
  swRegistration.pushManager.getSubscription()
  .then(function(subscription) {
    isSubscribed = !(subscription === null);

    if (isSubscribed) {
      console.log('User IS subscribed.');
    } else {
      console.log('User is NOT subscribed.');
    }

    // updateBtn();
  });
}

notifyMe();

function notifyMe() {
  // Let's check if the browser supports notifications
  const title = 'Welcome to BO Auction';
  const options = {
    body: 'Register, Bid and Become Winner!.',
    icon: 'media/frontend/images/logo-gram-bo-96.png',
    badge: 'media/frontend/images/logo-gram-bo-96.png'
  };
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }
  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== "denied") {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        navigator.serviceWorker.ready.then(function(registration) {
        registration.showNotification(title, options);
      });
      }
    });
  }

  // At last, if the user has denied notifications, and you
  // want to be respectful there is no need to bother them any more.
}
