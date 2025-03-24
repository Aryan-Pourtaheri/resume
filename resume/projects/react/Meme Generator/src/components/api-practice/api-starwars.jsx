import React from "react"
import { useEffect } from "react"

export default function App() {
    //useState Arrays
    const [starWarsData, setStarWarsData] = React.useState({})
    const [count,setCount] = React.useState(0)
    

    
    //side effect
    useEffect(function() {
        fetch(`https://swapi.dev/api/people/${count}`)
        .then(res => res.json())
        .then(data => setStarWarsData(data))
    },[count])
    
    return (
        <div>
            <pre>{JSON.stringify(starWarsData, null, 2)}</pre>
            <h1>The count is {count}</h1>
            <button onClick={(event) => setCount((prevCount) => prevCount + 1)}>Add</button>
        </div>
    )
}
