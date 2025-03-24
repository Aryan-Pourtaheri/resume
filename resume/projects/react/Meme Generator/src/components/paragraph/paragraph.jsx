import React from "react";
import boxes from "./boxes"
import Box from "./Box"
import './paragraph.css'
import { useState } from "react";

const Paragraph = () => {
    const [squares,setsquare] = useState(boxes)


    function toggle(id) {
        setsquare(prevSquares => {
                return prevSquares.map((square) => {
                    return square.id === id ? {...square,on: !square.on} : square
                })
        })
    }

    const squareElement = squares.map((square) => (
        <Box 
            toggle={() => toggle(square.id)} 
            key={square.id} 
            on={square.on}

        />

    ));


    return(
        <main>
            {squareElement}
        </main>
    )
    
}

export default Paragraph;