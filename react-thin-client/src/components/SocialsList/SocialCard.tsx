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

const PLATFORM_ICONS: Record<SocialPlatform, typeof FaYoutube> = {
  YOUTUBE: FaYoutube,
  BLUESKY: SiBluesky,
  TWITCH: FaTwitch,
  TWITTER: FaXTwitter,
  INSTAGRAM: FaInstagram,
  FACEBOOK: FaFacebook,
  TIKTOK: FaTiktok,
  DISCORD: FaDiscord,
  KICK: FaKickstarter,
};

const getPlatformClassName = (platform: SocialPlatform): string => {
  return `social-card--${platform.toLowerCase()}`;
};

const SocialCard = ({ social, index }: SocialCardProps) => {
  const Icon = PLATFORM_ICONS[social.platform];

  const handleClick = () => {
    window.open(social.url, '_blank', 'noopener,noreferrer');
  };

  return (
    <div
      className={`social-card ${getPlatformClassName(social.platform)}`}
      style={{
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