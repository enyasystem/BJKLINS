document.getElementById('bookingForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    document.getElementById('bookingConfirmation').style.display = 'block';
    document.getElementById('bookingConfirmation').innerHTML = `Thank you, ${name}! Your booking has been confirmed.`;
    document.getElementById('bookingForm').reset();
  });

  // Add animation class to sections when they come into view
  window.addEventListener('scroll', function () {
    const elements = document.querySelectorAll('.animated');
    for (let i = 0; i < elements.length; i++) {
      const element = elements[i];
      const position = element.getBoundingClientRect();
      if (position.top < window.innerHeight && position.bottom >= 0) {
        element.classList.add('fadeInUp');
      } else {
        element.classList.remove('fadeInUp');
      }
    }
  });

  // Show/hide Back to Top button
  window.addEventListener('scroll', function () {
    const backToTop = document.querySelector('.back-to-top');
    if (window.scrollY > 300) {
      backToTop.style.display = 'block';
    } else {
      backToTop.style.display = 'none';
    }
  });
