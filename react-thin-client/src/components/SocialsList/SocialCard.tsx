import { 
  FaYoutube, 
  FaTwitch, 
  FaXTwitter, 
  FaInstagram, 
  FaFacebook, 
  FaTiktok, 
  FaDiscord,
  FaKickstarter 
} from "react-icons/fa6";
import { SiBluesky } from "react-icons/si";
import type { SocialData, SocialPlatform } from './types';
import './SocialCard.css';

interface SocialCardProps {
  social: SocialData;
  index: number;
}

const PLATFORM_STYLES: Record<SocialPlatform, { backgroundColor: string; icon: typeof FaYoutube }> = {
  YOUTUBE: { backgroundColor: '#FF0000', icon: FaYoutube },
  BLUESKY: { backgroundColor: '#0F73FF', icon: SiBluesky },
  TWITCH: { backgroundColor: '#9146FF', icon: FaTwitch },
  TWITTER: { backgroundColor: '#000000', icon: FaXTwitter },
  INSTAGRAM: { backgroundColor: '#FCAF45', icon: FaInstagram },
  FACEBOOK: { backgroundColor: '#1877F2', icon: FaFacebook },
  TIKTOK: { backgroundColor: '#000000', icon: FaTiktok },
  DISCORD: { backgroundColor: '#5865F2', icon: FaDiscord },
  KICK: { backgroundColor: '#53FC18', icon: FaKickstarter },
};

const SocialCard = ({ social, index }: SocialCardProps) => {
  const { backgroundColor, icon: Icon } = PLATFORM_STYLES[social.platform];

  const handleClick = () => {
    window.open(social.url, '_blank', 'noopener,noreferrer');
  };

  return (
    <div
      className="social-card"
      style={{
        backgroundColor,
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