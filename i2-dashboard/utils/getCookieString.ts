/**
 * This function takes a jwt string and returns a cookie string to store as a cookie, including an expiration for the cookie.
 * @param token This is a string representation of a jwt or if you want to delete the cookie, can be anything
 * @param ttl This is the life of the cookie. If you want to delete the cookie, enter a negative number here
 * @returns 
 */
export default function getCookieString(token: string, ttl: number = 1): string {
    const expiration: string = new Date(Date.now() + ttl * 24 * 60 * 60 * 1000).toUTCString()
    return [
      `token=${token}; `,
      `SameSite=Strict; `,
      `Expires=${expiration}; `,
      `Path=/`
    ].join(" ");
  }