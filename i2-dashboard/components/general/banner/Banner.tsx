import styles from "./Banner.module.css";
import { SystemInfoType, UserType } from "@/types/models";
const Banner = ({ systemInfo, user }: { systemInfo: SystemInfoType; user: UserType;}) => {
  const property = systemInfo.propertyType ?? "";
  const banner = systemInfo.banner ?? "/banner.png";
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
