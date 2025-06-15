'use strict';

/**
 * Add event on multiple elements
 */
const addEventOnElements = function(elements, eventType, callback) {
    elements.forEach(element => {
        element.addEventListener(eventType, callback);
    });
};

/**
 * MOBILE NAVBAR
 * Navbar will show after clicking menu button
 */
const navbar = document.querySelector("[data-navbar]");
const navToggler = document.querySelector("[data-nav-toggler]");
const navLinks = document.querySelectorAll("[data-nav-link]");

const toggleNav = function() {
    navbar.classList.toggle("active");
    navToggler.classList.toggle("active");
    
    // Flare effect on toggle button
    navToggler.classList.add("flared");
    setTimeout(() => {
        navToggler.classList.remove("flared");
    }, 300); // Flare duration
};

navToggler.addEventListener("click", toggleNav);

const navClose = () => {
    navbar.classList.remove("active");
    navToggler.classList.remove("active");
};

addEventOnElements(navLinks, "click", navClose);

/**
 * HEADER and BACK TOP BTN
 * Header and back top button will be active after scrolling down 100px of screen
 */
const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

const activeEl = function() {
    const isScrolled = window.scrollY > 100;
    header.classList.toggle("active", isScrolled);
    backTopBtn.classList.toggle("active", isScrolled);
};

window.addEventListener("scroll", activeEl);

/**
 * Button hover ripple effect
 */
const buttons = document.querySelectorAll("[data-btn]");

const buttonHoverRipple = function(event) {
    const { offsetX, offsetY } = event;
    this.style.setProperty("--top", `${offsetY}px`);
    this.style.setProperty("--left", `${offsetX}px`);
    
    // Flare effect on button hover
    this.classList.add("flared");
    setTimeout(() => {
        this.classList.remove("flared");
    }, 300); // Flare duration
};

addEventOnElements(buttons, "mousemove", buttonHoverRipple);

/**
 * Scroll reveal
 */
const revealElements = document.querySelectorAll("[data-reveal]");

const revealElementOnScroll = function() {
    revealElements.forEach(element => {
        const isElementInsideWindow = element.getBoundingClientRect().top < window.innerHeight / 1.1;
        if (isElementInsideWindow) {
            element.classList.add("revealed");
            
            // Flare effect on reveal
            element.classList.add("flared");
            setTimeout(() => {
                element.classList.remove("flared");
            }, 500); // Flare duration
        }
    });
};

window.addEventListener("scroll", revealElementOnScroll);
window.addEventListener("load", revealElementOnScroll);

/**
 * Custom cursor
 */
const cursor = document.querySelector("[data-cursor]");
const hoverElements = [...document.querySelectorAll("a"), ...document.querySelectorAll("button")];

const cursorMove = function(event) {
    const { clientX, clientY } = event;
    cursor.style.top = `${clientY}px`;
    cursor.style.left = `${clientX}px`;
};

window.addEventListener("mousemove", cursorMove);

addEventOnElements(hoverElements, "mouseover", () => cursor.classList.add("hovered"));
addEventOnElements(hoverElements, "mouseout", () => cursor.classList.remove("hovered"));
