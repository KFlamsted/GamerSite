import BackgroundVideoComponent from './BackgroundVideoComponent';
import ScrollDownIndicator from '../components/ScrollDownIndicator/ScrollDownIndicator';
import './LandingPage.css';

const LandingPage = () => {
  return (
    <div className="landing-page">
      <BackgroundVideoComponent videoSrc="/videos/background.mp4" />
      <div className="landing-content">
        <h1 className="landing-title">Velkommen til Novaz gamer!</h1>
      </div>
      <ScrollDownIndicator />
    </div>
  );
};

export default LandingPage;
