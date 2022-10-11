const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const altTema = document.querySelector(".alt-tema");
const themeDark = altTema.querySelector("span:nth-child(2)");
const themeLight = altTema.querySelector("span:nth-child(1)");

//mostrar menu
menuBtn.addEventListener("click", () => {
  sideMenu.style.display = "block";
});
//fechar menu
closeBtn.addEventListener("click", () => {
  sideMenu.style.display = "none";
});

function handleTheme(themeSelected) {
  localStorage.setItem("themeSelected", themeSelected);
  document.body.classList.toggle("tema-dark");
  themeDark.classList.toggle("ativo");
  themeLight.classList.toggle("ativo");
}

function startTheme() {
  let theme = localStorage.getItem("themeSelected") || "light";

  if (theme === "dark") {
    document.body.classList.add("tema-dark");
    themeDark.classList.toggle("ativo");
  } else if (theme === "light") {
    themeLight.classList.toggle("ativo");
  }
}

startTheme();
