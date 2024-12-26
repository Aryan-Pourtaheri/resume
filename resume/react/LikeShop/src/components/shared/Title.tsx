import { motion } from 'framer-motion';
import { Button } from '../ui/button';
import { useNavigate } from 'react-router-dom';

const Title = ({ user }) => {
  const navigate = useNavigate()
  
  return (
    <>
      <div className="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-40">
        <motion.h1
          className="title m-3 text-9xl"
          initial={{ opacity: 0, y: -50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 2 }}
        >

            <p className='m-10'><span className="text-purple-600">Like</span><span className="text-red-500">Shop</span></p>



        </motion.h1>

        <motion.button
          initial={{ opacity: 0, x: -50}}
          animate={{ opacity: 1, x: 0}}
          transition={{ duration: 2 }}
        >
            <Button
              className='bg-teal-800 hover:bg-teal-900 text-xl py-6'
              onClick={() => {
                user ? navigate('/products') : navigate('/log-in')
              }}

            >
                  {user ? 'Shop Here' : 'Start Here'}
            </Button>
          </motion.button>
      </div>
    </>
  );
};

export default Title;