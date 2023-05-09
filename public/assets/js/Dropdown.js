const handleDropdownClicked = () => {
  const dropdown = document.getElementById("dropdown");
  toggleDropdown(!dropdown?.classList?.contains("open"));
};
const handleSubMenuClicked = (subMenuId) => {
  if (subMenuId) {
    const subMenus = document.getElementsByClassName("sub-menu");
    for (let s of subMenus) {
      s.classList.remove("open");
    }
    const subMenu = document.getElementById(subMenuId);
    subMenu.classList.add("open");
    const menu = document.getElementById("menu");
    menu.style.height = subMenu.clientHeight + "px";
  } else {
    menu.style.height = "168px";
  }

  const menuInner = document.getElementById("menu-inner");
  menuInner.classList.toggle("open");
};

const toggleDropdown = () => {
  const dropdown = document.getElementById("dropdown");
  dropdown.classList.toggle("open");
};
