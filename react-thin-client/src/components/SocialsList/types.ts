import type { IconType } from 'react-icons';

export type SocialPlatform = 'YOUTUBE' | 'BLUESKY' | 'TWITCH' | 'TWITTER' | 'INSTAGRAM';

export interface SocialData {
  platform: SocialPlatform;
  handle: string;
  url: string;
  backgroundColor: string;
  icon: IconType;
  thumbnail?: string;
}
