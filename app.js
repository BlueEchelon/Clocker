const menuToggle = document.getElementById('menu-toggle')
const mobileMenu = document.getElementById('mobile-menu')
const mobileLinks = document.querySelectorAll('.mobile-link')

window.addEventListener('resize', () => {
  if (window.innerWidth >= 900) {
    menuToggle.classList.remove('toggle')
    mobileMenu.classList.remove('show')
    document.body.style.overflow = 'auto'
  }
})

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('toggle')
  mobileMenu.classList.toggle('show')

  if (menuToggle.classList.contains('toggle')) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = 'auto'
  }
})

mobileLinks.forEach((link) => {
  link.addEventListener('click', () => {
    menuToggle.classList.remove('toggle')
    mobileMenu.classList.remove('show')
    document.body.style.overflow = 'auto'
  })
})

const editBtn = document.getElementById('edit-task')
const projectNames = document.querySelectorAll('#project-name')

Array.from(projectNames).forEach((project) => {
  project.addEventListener('click', () => {
    editBtn.value = project.innerText
  })
})
