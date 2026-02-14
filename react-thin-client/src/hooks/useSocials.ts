import { useContext } from 'react';
import { SocialsContext } from '../context/SocialsContextDefinition';
import type { SocialData } from '../components/SocialsList/types';

export function useSocials(): SocialData[] {
  const context = useContext(SocialsContext);
  return context.socials;
}
