import { NextApiRequest } from "next";

const copyHeaders = (req: NextApiRequest) => {
    return {
        'Content-Type': req.headers['content-type'] as string,
        'Authorization': req.headers.authorization as string,
      };
}

export default copyHeaders;