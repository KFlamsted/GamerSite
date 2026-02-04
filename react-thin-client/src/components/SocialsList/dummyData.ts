import { FaYoutube, FaTwitch } from "react-icons/fa6";
import { SiBluesky } from "react-icons/si";
import type { SocialData } from "./types";

export const socialMediaData: SocialData[] = [
  {
    platform: "YOUTUBE",
    handle: "@NovazGamer",
    url: "https://youtube.com/@novazgamer",
    backgroundColor: "#FF0000",
    icon: FaYoutube,
  },
  {
    platform: "BLUESKY",
    handle: "@novazgaming.bsky.social",
    url: "https://bsky.app/profile/novazgaming.bsky.social",
    backgroundColor: "#0F73FF",
    icon: SiBluesky,
  },
  {
    platform: "TWITCH",
    handle: "@datNovazGG",
    url: "https://twitch.tv/datNovazGG",
    backgroundColor: "#9146FF",
    icon: FaTwitch,
  },
  //   {
  //     platform: 'TWITTER',
  //     handle: '@NovazGamer',
  //     url: 'https://twitter.com/novazgamer',
  //     backgroundColor: '#000000',
  //     icon: FaXTwitter,
  //   },
  //   {
  //     platform: 'INSTAGRAM',
  //     handle: '@NovazGamer',
  //     url: 'https://instagram.com/novazgamer',
  //     backgroundColor: '#FCAF45',
  //     icon: FaInstagram,
  //   },
];
