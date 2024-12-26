import './Home.css';
import { useAuth } from '@/lib/appwrite/AuthContext';
import Title from '@/components/shared/Title';

const Home = () => {
  const { user } = useAuth();
  return (
    <div className="relative h-full w-full">
      <div className="video-container">
        <video
          src="assets/videos/shopping-center.mp4"
          loop
          autoPlay
          muted
          className="absolute top-0 left-0 w-10/12 h-full object-cover"
        />
      </div>

      <div className="content-container flex items-center justify-center h-full">
        <Title user={user} />
      </div>
    </div>
  );
};

export default Home;
