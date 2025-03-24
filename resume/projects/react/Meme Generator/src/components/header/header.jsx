import React from "react";
import logo from "../header/trollface.svg";
import './header.css';

const Header = () => {
    return (
        <header className="header">
            <div style={{ display: "flex", alignItems: "center" }}>
                <img className="header--image" src={logo} alt="troll face" />
                <h2 className="header--title">Meme Generator</h2>
            </div>
            <h3 className="header--project">React Course - Project 3</h3>
        </header>
    );
};

export default Header;
