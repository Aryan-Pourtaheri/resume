import React from "react";
import './inputer.css'
import { useState } from "react";

const Inputer = () => {
    const [formData,setFormData] = useState(
        {
        firstName:"",
        lastName:"",
        email:"",
        comments:"",
        isFriendly:true,
        employment:"",
        favcolor:""
    })


    function handleChange(event) {
        const{name,value,type,checked} = event.target
        setFormData(prevFormData => {
            return{
                ...prevFormData,
                [name]: type === "checkbox" ? checked : value

                

            }
        })
    }


    return(
        <main>
            <form onSubmit={formData}>
                
                <input 
                    type="text" 
                    name="firstName" 
                    onChange={handleChange}
                    placeholder="first name"
                    value={formData.firstName}
                    
                />
                

                <input 
                    type="text" 
                    name="lastName" 
                    onChange={handleChange}
                    placeholder="last name"
                    value={formData.lastName}
                />

                <input 

                    type="text" 
                    name="email" 
                    onChange={handleChange}
                    placeholder="Email"
                    value={formData.email}
                />

                <textarea 
                    rows={10} cols={20} 
                    onChange={handleChange} 
                    name="comments"
                    placeholder="comment"
                    value={formData.comments}

                />

                <input
                    type="checkbox"
                    id="isFriendly"
                    checked={formData.isFriendly}    
                    onChange={handleChange}
                />

                <label htmlFor="isFriendly">Are You Friendly?</label>

                <fieldset>
                    <legend>current employment status</legend>

                    <input
                        type="radio"
                        id="unemployed"
                        name="employment"
                        value="unemployed"
                        checked={formData.employment === "unemployed"}
                        onChange={handleChange}
                    />
                    <label htmlFor="unemployed">Unemployed</label>

                    <br/>
                    <input
                        type="radio"
                        id="part-time"
                        name="employment"
                        value="part-time"
                        checked={formData.employment === "part-time"}
                        onChange={handleChange}
                    />
                    <label htmlFor="part-time">part-time</label>

                    <br/>
                    <input
                        type="radio"
                        id="full-time"
                        name="employment"
                        value="full-time"
                        checked={formData.employment === "full-time"}
                        onChange={handleChange}
                    />
                    <label htmlFor="full-time">full-time</label>

                    
                </fieldset>

                <label htmlFor="favcolor">What is your favourit color ?</label>

                <select
                    id="favcolor"
                    value={formData.favcolor}
                    onChange={handleChange}
                    name="favcolor"
                >
                    {/* <option value="choose">--choose--</option> */}
                    <option value="red">Red</option>
                    <option value="orange">Orange</option>
                    <option value="yellow">Yellow</option>
                    <option value="green">green</option>
                    <option value="blue">blue</option>
                    <option value="indigo">Indigo</option>
                    <option value="violet">Violet</option>
                </select>

                <br/>
                <br/>

                <button>Submit</button>
            </form>
        </main>
    )

}

export default Inputer;