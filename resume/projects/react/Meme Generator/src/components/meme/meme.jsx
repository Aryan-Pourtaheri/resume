import React, { useEffect } from "react";
import './meme.css'
import memeData from './memeData'
import { useState } from "react";
// import { useEffect } from "react";

const Meme = () => {

    const[meme,setmeme] = useState({
        topText:"",
        bottomText:"",
        randomImage:"https://i.imgflip.com/1bij.jpg"
    })

    const [allMemes, setAllMemes] = React.useState([])



    function getMemeImage() {
        const memeArray = memeData.data.memes;
        const randomNumber = Math.floor(Math.random() * memeArray.length);
        const url = memeArray[randomNumber].url;
        console.log(url);
        setmeme(prevmeme => ({
            ...prevmeme,
            randomImage: url
        }))
    }

    function handleClick(event) {
        const {name,value} = event.target
        setmeme(prevMeme => ({
            ...prevMeme,
            [name]:value
        }))
        
    }


    useEffect(() => {
        async function getMemes() {
            const res = await fetch("https://api.imgflip.com/get_memes")
            const data = await res.json()
            setAllMemes(data.data.memes)
        }
        getMemes()
    }, [])
     


    return(
        <main>
            <div className="form">
                <input 
                    type="text"
                    placeholder="Top text"
                    className="form--input"
                    name="topText"
                    value={meme.topText}
                    onChange={handleClick}

                />
                <input 
                    type="text"
                    placeholder="Buttom text"
                    className="form--input"
                    name="bottomText"
                    value={meme.bottomText}
                    onChange={handleClick}

                />

                <button 
                    className="form--button"
                    onClick={getMemeImage}    
                >
                    Get a new meme image  🖼️
                </button>
            </div>
            <div className="meme--image">
                <img src={meme.randomImage} alt='random' className="meme--Image--item"/>
                <h2 className="image--paragraph1">{meme.topText}</h2>
                <h2 className="image--paragraph2">{meme.bottomText}</h2>
            </div>
        </main>
    )
}

export default Meme;