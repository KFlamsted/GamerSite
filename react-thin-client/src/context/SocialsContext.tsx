import { useEffect, useState, type ReactNode } from "react";
import { socialMediaData } from "../components/SocialsList/dummyData";
import { fetchSocials } from "../services/wordpressService";
import { SocialsContext } from "./SocialsContextDefinition";

interface SocialsProviderProps {
  children: ReactNode;
}

export function SocialsProvider({ children }: SocialsProviderProps) {
  const [socials, setSocials] = useState(socialMediaData);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    let isMounted = true;

    async function loadSocials() {
      try {
        const data = await fetchSocials();
        if (isMounted) {
          setSocials(data);
          setError(null);
        }
      } catch (err) {
        if (isMounted) {
          console.error(
            "Failed to load socials from WordPress, using fallback data",
            err,
          );
          setError("Failed to load from WordPress");
          // Already using dummy data as default
        }
      } finally {
        if (isMounted) {
          setLoading(false);
        }
      }
    }

    loadSocials();

    return () => {
      isMounted = false;
    };
  }, []);

  return (
    <SocialsContext.Provider value={{ socials, loading, error }}>
      {children}
    </SocialsContext.Provider>
  );
}
