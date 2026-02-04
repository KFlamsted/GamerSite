import type { SocialData } from './types';
import './SocialCard.css';

interface SocialCardProps {
  social: SocialData;
  index: number;
}

const SocialCard = ({ social, index }: SocialCardProps) => {
  const Icon = social.icon;

  const handleClick = () => {
    window.open(social.url, '_blank', 'noopener,noreferrer');
  };

  return (
    <div
      className="social-card"
      style={{
        backgroundColor: social.backgroundColor,
        animationDelay: `${index * 0.1}s`,
      }}
      onClick={handleClick}
      role="button"
      tabIndex={0}
      onKeyDown={(e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          handleClick();
        }
      }}
    >
      <div className="social-card-icon">
        <Icon size={32} />
      </div>
      <div className="social-card-handle">{social.handle}</div>
      {social.thumbnail && (
        <div className="social-card-thumbnail">
          <img src={social.thumbnail} alt={`${social.platform} thumbnail`} />
        </div>
      )}
    </div>
  );
};

export default SocialCard;
