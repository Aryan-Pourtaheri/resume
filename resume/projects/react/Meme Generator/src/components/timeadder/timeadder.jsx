import './timeadder.css'
import React from 'react';
import { useState } from 'react';

const Timeadder = () => {
    const [count,setCount] = useState(0);

    function pluser() {
        setCount(prevCount => prevCount+1)
    }

    function minuser() {
        setCount(prevCount => prevCount-1)
    }

    return (
        <>
            <div className='Counter'>
                <button className='plus--btn' onClick={pluser}>+</button>
                <button className='minus--btn' onClick={minuser}>-</button> 
                <div>
                    <h1 className='counted'>{count}</h1>
                </div>
                   
            </div>

        </>
    )
}

export default Timeadder;