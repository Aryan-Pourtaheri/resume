import './App.css';
import { useState } from "react";

function App() {
  const [inputValue, setInputValue] = useState('');

  const clickHandler = (e) => { 
    setInputValue(inputValue + e.target.value);
  }

  return (
    <div className="App">
      <div className="container">
        <div className="input-number">
          <div className='operation-container'>
            <input 
              type='text'
              name='text-input'
              id='text-input'
              className='text-input'
              value={inputValue}
            />
          </div>
        </div>
        <div className='button-container'>
          <button className='btn-symbol' onClick={() => setInputValue("")}>AC</button>
          <button className='btn-symbol' onClick={() => setInputValue(inputValue.slice(0,-1))}>DE</button>
          <button value={'.'} className='btn-symbol' onClick={(e) => clickHandler(e)}>.</button>
          <button value={'/'} className='btn-symbol' onClick={(e) => clickHandler(e)}>/</button>
          <button value={'7'} className="btn-number number7" onClick={(e) => clickHandler(e)}>7</button>
          <button value={'8'} className="btn-number number8" onClick={(e) => clickHandler(e)}>8</button>
          <button value={'9'} className="btn-number number9" onClick={(e) => clickHandler(e)}>9</button>
          <button value={'+'} className='btn-symbol symbol-addition' onClick={(e) => clickHandler(e)}>+</button> 
          <button value={'4'} className="btn-number number4" onClick={(e) => clickHandler(e)}>4</button>
          <button value={'5'} className="btn-number number5" onClick={(e) => clickHandler(e)}>5</button>
          <button value={'6'} className="btn-number number6" onClick={(e) => clickHandler(e)}>6</button>
          <button value={'−'} className='btn-symbol symbol-subtraction' onClick={(e) => clickHandler(e)}>−</button>  
          <button value={'1'} className="btn-number number1" onClick={(e) => clickHandler(e)}>1</button>
          <button value={'2'} className="btn-number number2" onClick={(e) => clickHandler(e)}>2</button>
          <button value={'3'} className="btn-number number3" onClick={(e) => clickHandler(e)}>3</button>
          <button value={'*'} className='btn-symbol symbol-multiplication' onClick={(e) => clickHandler(e)}>×</button>
          <button value={'00'} className='btn-symbol' onClick={(e) => clickHandler(e)}>00</button>
          <button value={'0'} className="btn-symbol number0" onClick={(e) => clickHandler(e)}>0</button>
          <button value={"="} className='btn-symbol btn-equals' onClick={(e) => setInputValue(eval(inputValue))}>=</button> 
        </div>
      </div>
    </div>
  );
}

export default App;
