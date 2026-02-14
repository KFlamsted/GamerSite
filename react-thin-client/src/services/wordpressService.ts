import axios from 'axios';
import type { SocialData } from '../components/SocialsList/types';

interface WordPressSocialCard {
  id: number;
  handle: string;
  url: string;
  platform: string;
}

const WORDPRESS_URL = import.meta.env.VITE_WORDPRESS_URL;

export async function fetchSocials(): Promise<SocialData[]> {
  if (!WORDPRESS_URL) {
    console.warn('VITE_WORDPRESS_URL not set, cannot fetch socials from WordPress');
  }

  const endpoint = `${WORDPRESS_URL}/wp-json/wp/v2/social-card?_fields=id,handle,url,platform`;
  const response = await axios.get<WordPressSocialCard[]>(endpoint);
  
  return response.data.map(card => ({
    platform: card.platform as SocialData['platform'],
    handle: card.handle,
    url: card.url,
    // No thumbnail for now
  }));
}
