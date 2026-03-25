/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/*===== MENU SHOW =====*/
if(navToggle){
    navToggle.addEventListener('click', () =>{
        navMenu.classList.add('show-menu')
    })
}

/*===== MENU HIDDEN =====*/
if(navClose){
    navClose.addEventListener('click', ()=>{
        navMenu.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

const linkAction = () =>{
    const navMenu = document.getElementById('nav-menu')
    if(navMenu) {
        navMenu.classList.remove('show-menu')
    }
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*=============== CHANGE BACKGROUND HEADER ===============*/
const scrollHeader = () =>{
    const header = document.getElementById('header')
    if(header) {
        this.scrollY >= 50 ? header.classList.add('scroll-header')
                           : header.classList.remove('scroll-header')
    }
}
window.addEventListener('scroll', scrollHeader)

/*=============== SHADOW HEADER ===============*/
const shadowHeader = () =>{
    const header = document.getElementById('header')
    if(header) {
        this.scrollY >= 50 ? header.classList.add('shadow-header')
                           : header.classList.remove('shadow-header')
    }
}
window.addEventListener('scroll', shadowHeader)

/*=============== EMAIL JS ===============*/
const contactForm = document.getElementById('contact-form'),
      contactMessage = document.getElementById('contact-message')

const sendEmail = (e) =>{
    e.preventDefault()

    // serviceID - templateID - #form - publicKey
    emailjs.sendForm('service_7gn4w8w','template_ait79iq','#contact-form','Tu-w49ViUThHMRfsm')
    .then(() =>{
        contactMessage.textContent = 'Message sent successfully ✅'
        setTimeout(() =>{
            contactMessage.textContent = ''
        }, 5000)
        contactForm.reset()
    }, () =>{
        contactMessage.textContent = 'Message not sent (service error) ❌'
    })
}   

if(contactForm) {
    contactForm.addEventListener('submit', sendEmail)
}

/*=============== SHOW SCROLL UP ===============*/ 
const scrollUp = () =>{
    const scrollUpBtn = document.getElementById('scroll-up')
    if(scrollUpBtn) {
        this.scrollY >= 350 ? scrollUpBtn.classList.add('show-scroll')
                            : scrollUpBtn.classList.remove('show-scroll')
    }
}
window.addEventListener('scroll', scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

const scrollActive = () =>{
    const scrollDown = window.scrollY

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight,
              sectionTop = current.offsetTop - 58,
              sectionId = current.getAttribute('id')
              
        const sectionsClass = document.querySelector('.nav__menu a[href*="' + sectionId + '"]')

        if(sectionsClass) {
            if(scrollDown > sectionTop && scrollDown <= sectionTop + sectionHeight){
                sectionsClass.classList.add('active-link')
            }else{ 
                sectionsClass.classList.remove('active-link')
            }
        }
    })
}
window.addEventListener('scroll', scrollActive)

/*=============== DARK LIGHT THEME ===============*/ 
const themeButton = document.getElementById('theme-button')
const darkTheme = 'dark-theme'
const iconTheme = 'ri-sun-line'

const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

if (themeButton) {
    const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
    const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'ri-moon-line' : 'ri-sun-line'

    if (selectedTheme){
        document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
        themeButton.classList[selectedIcon === 'ri-moon-line' ? 'add' : 'remove'](iconTheme)
    }

    themeButton.addEventListener('click', () => {
        document.body.classList.toggle(darkTheme)
        themeButton.classList.toggle(iconTheme)
        localStorage.setItem('selected-theme', getCurrentTheme())
        localStorage.setItem('selected-icon', getCurrentIcon())
    })
}

/*=============== SCROLL REVEAL ANIMATION ===============*/
if (typeof ScrollReveal !== 'undefined') {
    const sr = ScrollReveal({
        origin: 'top',
        distance: '60px',
        duration: 2500,
        delay: 400,
    })

    sr.reveal(`.home__perfil, .about__image, .contact__mail`, {origin: 'right'})
    sr.reveal(`.home__name, .home__info,
               .about__container .section__title-1, .about__info,
               .contact__social, .contact__data`, {origin: 'left'})
    sr.reveal(`.experience__card, .projects__card`, {interval: 100})
}