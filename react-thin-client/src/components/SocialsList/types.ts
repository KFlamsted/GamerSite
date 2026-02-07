export type SocialPlatform = 
  | 'YOUTUBE' 
  | 'BLUESKY' 
  | 'TWITCH' 
  | 'TWITTER' 
  | 'INSTAGRAM'
  | 'FACEBOOK'
  | 'TIKTOK'
  | 'DISCORD'
  | 'KICK';

export interface SocialData {
  platform: SocialPlatform;
  handle: string;
  url: string;
  thumbnail?: string;
}
