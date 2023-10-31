import ViewSoa from "@/components/pages/viewsoa/ViewSoa"

export async function getServerSideProps(context: any) {
    console.log("inside viewsoa")
    return {
        props: {}
    }
}

export default ViewSoa