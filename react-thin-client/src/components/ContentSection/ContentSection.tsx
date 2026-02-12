import DescriptionComponent from './DescriptionComponent';
import SocialsList from '../SocialsList/SocialsList';
import './ContentSection.css';

const ContentSection = () => {
  return (
    <section className="content-section">
      <div className="content-container">
        <h1 className="content-title">Velkommen til Novaz Gamer</h1>
        <DescriptionComponent />
        <SocialsList />
      </div>
    </section>
  );
};

export default ContentSection;
