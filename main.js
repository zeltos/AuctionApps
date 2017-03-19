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
  const title = 'Notification Auction Apps';
  const options = {
    body: 'Yay it works.',
    icon: 'media/frontend/images/logo-gram-bo-96.png',
    badge: 'media/frontend/images/logo-gram-bo-96.png'
  };
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have already been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    var notification = new Notification(title,options);
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== "denied") {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        var notification = new Notification(title,options);
      }
    });
  }

  // At last, if the user has denied notifications, and you
  // want to be respectful there is no need to bother them any more.
}
