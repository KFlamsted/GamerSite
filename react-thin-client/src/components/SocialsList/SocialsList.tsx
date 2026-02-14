import { Grid } from '@mui/material';
import SocialCard from './SocialCard';
import { useSocials } from '../../hooks/useSocials';
import './SocialsList.css';

const SocialsList = () => {
  const socials = useSocials();
  const shouldUseGrid = socials.length > 5;

  return (
    <div className="socials-list">
      {shouldUseGrid ? (
        <Grid container spacing={2}>
          {socials.map((social, index) => (
            <Grid key={social.platform} size={{ xs: 12, sm: 6 }}>
              <SocialCard social={social} index={index} />
            </Grid>
          ))}
        </Grid>
      ) : (
        <div className="socials-list-vertical">
          {socials.map((social, index) => (
            <SocialCard key={social.platform} social={social} index={index} />
          ))}
        </div>
      )}
    </div>
  );
};

export default SocialsList;
