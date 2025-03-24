import React from "react";
import './h1.css'
import { useState } from "react";

const Hone = () => {
    const [messege,setmessege] = useState(['a','b']);

    return (
        <main>
            {
                messege.length === 0 ? 
                <h1>you're all</h1>:
                <h1>you have {messege.length} unread {messege.length > 1 ? "message" : "messege"}</h1>
            }
        </main>
    )
}

export default Hone;