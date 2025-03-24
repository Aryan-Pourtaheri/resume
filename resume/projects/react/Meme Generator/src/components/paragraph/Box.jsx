import React from "react";
// import Boxes from './boxes'
// import { useState } from "react";

const Box = (props) => {

    const styles = {
        backgroundColor: props.on ? '#222222': 'transparent'
    }


       
    return(
        <div style={styles} onClick={props.toggle} className='box'></div>
        
    )
}

export default Box;