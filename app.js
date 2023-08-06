// Close the toast after a few seconds
setTimeout(function () {
  var toast = document.getElementById("toast");
  if (toast) {
    toast.style.display = "none";
  }
}, 5000);
