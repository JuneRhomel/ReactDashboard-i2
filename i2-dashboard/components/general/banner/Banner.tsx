import styles from "./Banner.module.css";
import { SystemType, UserType } from "@/types/models";
const Banner = ({ systemInfo, user }: { systemInfo: SystemType[]; user: UserType;}) => {
  const property = systemInfo[0].propertyType ?? "";
  const banner = systemInfo[0].banner ?? "/banner.png";
  let displayName = property === "Commercial" ? user.companyName : `${user.firstName} ${user.lastName}`;
  return (
    <div className={styles.banner}>
      <h1>
        WELCOME <br /> <span>{displayName}</span>
      </h1>
      <img src={banner} alt="" />
    </div>
  );
};

export default Banner;
