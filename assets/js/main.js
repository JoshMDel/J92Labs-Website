/* J92 Labs — site scripts */
document.addEventListener("DOMContentLoaded", function () {
  /* Mobile nav toggle -------------------------------------------------- */
  var header = document.querySelector(".site-header");
  var toggle = document.querySelector(".nav-toggle");

  if (toggle && header) {
    toggle.addEventListener("click", function () {
      var isOpen = header.classList.toggle("nav-open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    document.querySelectorAll(".main-nav a").forEach(function (link) {
      link.addEventListener("click", function () {
        header.classList.remove("nav-open");
      });
    });
  }
});
