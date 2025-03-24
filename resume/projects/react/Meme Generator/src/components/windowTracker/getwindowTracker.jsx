import React from "react"
import WindowTracker from "./windowTracker"
import './windowTracker.css'
import { useState } from "react"

export default function App() {
    
    const [show,setshow] = useState(false)

    function toggle() {
        setshow(prevshow => !prevshow)
    }

    return (
        <div className="container">
            <button onClick={toggle}>
                Toggle WindowTracker
            </button>
            {show && <WindowTracker/>}
        </div>
    )
}
