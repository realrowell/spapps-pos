export default function clearSelect(path: string, form: any) {
    const keys = path.split('.')
    let target: any = form // allow dynamic indexing

    for (let i = 0; i < keys.length - 1; i++) {
        target = target[keys[i]]
        if (!target) return
    }

    target[keys[keys.length - 1]] = null
}
