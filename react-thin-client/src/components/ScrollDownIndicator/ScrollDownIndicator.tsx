import './ScrollDownIndicator.css';

const ScrollDownIndicator = () => {
  const handleScrollDown = () => {
    window.scrollTo({
      top: window.innerHeight,
      behavior: 'smooth'
    });
  };

  return (
    <div className="scroll-down-indicator" onClick={handleScrollDown}>
      <div className="arrow-down">▼</div>
    </div>
  );
};

export default ScrollDownIndicator;
