import React from "react"
import { useEffect } from "react"
import { useState } from "react"

export default function WindowTracker() {
    const [windowWidth,setWindow] = useState(window.innerWidth);
    useEffect(() => {
        function watchWidth() {
            console.log('working')
            setWindow(window.innerWidth)
        }

        window.addEventListener('resize',watchWidth)


        return function () {
            console.log('cleaned')
            window.removeEventListener('resize', watchWidth)
        }
    },[])
    return (
        <h1>Window width: {windowWidth}</h1>
    )
}
