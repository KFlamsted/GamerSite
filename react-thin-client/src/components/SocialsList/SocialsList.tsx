import { Grid } from '@mui/material';
import SocialCard from './SocialCard';
import { socialMediaData } from './dummyData';
import './SocialsList.css';

const SocialsList = () => {
  const shouldUseGrid = socialMediaData.length > 5;

  return (
    <div className="socials-list">
      {shouldUseGrid ? (
        <Grid container spacing={2}>
          {socialMediaData.map((social, index) => (
            <Grid key={social.platform} size={{ xs: 12, sm: 6 }}>
              <SocialCard social={social} index={index} />
            </Grid>
          ))}
        </Grid>
      ) : (
        <div className="socials-list-vertical">
          {socialMediaData.map((social, index) => (
            <SocialCard key={social.platform} social={social} index={index} />
          ))}
        </div>
      )}
    </div>
  );
};

export default SocialsList;
