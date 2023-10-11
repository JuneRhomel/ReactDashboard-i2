import Layout from "@/components/layouts/layout";
import Section from "@/components/general/section/Section";

export default function myrequest() {
  const props = {
    title: "Requests",
    headerAction: null,
  }
  
  return (
    <Layout title='i2 - Requests'>
      <Section props={props}/>
    </Layout>
  )
}
