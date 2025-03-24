import './pprofile.css'
import profile from './images/profile.png'
import Ystar from './images/y-star.png'
import Estar from './images/empty-star.png'
import { useState } from 'react'

const Pprofile = () =>{
    const [contact,setContact] = useState({
        name:'john',
        lastname:'doe',
        phone:'+1 532 324 34 66',
        email:'johndoe@gmail.com',
        starLike: Ystar,
        dontstarLike:Estar,
        isFavorit:false

    });

    let starIcon = contact.isFavorit ? Estar:Ystar;

    function Ichose(params) {
        setContact(prevContact =>({
            ...prevContact,
            isFavorit: !prevContact.isFavorit
        })
            
            
        )
    }

    return (
        <div className='card' onClick={Ichose} >
            <div>
                <img className='profile--image' src={profile} alt='profile'/>
            </div>
            <img 
                className='star--image' 
                src={starIcon} 
                alt='profile'
        
            />
            <h1>{contact.name + ' ' + contact.lastname}</h1>
            <h3>email:{contact.email}</h3>
            <h3>phone:{contact.phone}</h3>
            
        </div>
)}

export default Pprofile;