let lastScrollTop = 0;
const header = document.querySelector('.header-hide-show');

if (header) {
  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll < lastScrollTop) {
      // Scrolling up → show header
      header.style.transform = 'translateY(0)';
    } else {
      // Scrolling down → hide header
      header.style.transform = 'translateY(-100%)';
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  });
}
