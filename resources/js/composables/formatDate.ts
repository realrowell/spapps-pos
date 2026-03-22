export default function formatDate(date: Date){
    return new Intl.DateTimeFormat(undefined, {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
    }).format(new Date(date))
}
