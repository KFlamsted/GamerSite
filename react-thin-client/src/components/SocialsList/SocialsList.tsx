import SocialCard from './SocialCard';
import { socialMediaData } from './dummyData';
import './SocialsList.css';

const SocialsList = () => {
  return (
    <div className="socials-list">
      {socialMediaData.map((social, index) => (
        <SocialCard key={social.platform} social={social} index={index} />
      ))}
    </div>
  );
};

export default SocialsList;
