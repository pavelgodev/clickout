/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
document.addEventListener('DOMContentLoaded', function () {
  const expandButtons = document.querySelectorAll('.author-bio__expand-btn');
  expandButtons.forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      const container = this.closest('.author-bio');
      console.log(container);
      const trimmed = container.querySelector('.author-bio__content--trimmed');
      const full = container.querySelector('.author-bio__content--full');
      if (full.classList.contains('hide')) {
        trimmed.classList.add('hide');
        full.classList.remove('hide');
        this.textContent = 'Collapse';
      } else {
        full.classList.add('hide');
        trimmed.classList.remove('hide');
        this.textContent = 'Expand';
      }
    });
  });
});
/******/ })()
;
//# sourceMappingURL=main.js.map