import './BackgroundVideoComponent.css';

interface BackgroundVideoComponentProps {
  videoSrc: string;
}

const BackgroundVideoComponent = ({ videoSrc }: BackgroundVideoComponentProps) => {
  return (
    <div className="background-video-container">
      <video
        className="background-video"
        autoPlay
        muted
        loop
        playsInline
        src={videoSrc}
      >
        Your browser does not support the video tag.
      </video>
    </div>
  );
};

export default BackgroundVideoComponent;
