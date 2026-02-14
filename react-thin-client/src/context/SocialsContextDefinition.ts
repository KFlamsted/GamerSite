import { createContext } from "react";
import type { SocialData } from "../components/SocialsList/types";
import { socialMediaData } from "../components/SocialsList/dummyData";

export interface SocialsContextType {
  socials: SocialData[];
  loading: boolean;
  error: string | null;
}

export const SocialsContext = createContext<SocialsContextType>({
  socials: socialMediaData,
  loading: true,
  error: null,
});
