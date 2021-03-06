// See https://stackoverflow.com/a/237176

export const contains = (
    array: string[],
    string: string
): boolean => {
    let index = array.length;

    while (index--) {
        if (array[index] === string) {
            return true;
        }
    }

    return false;
};
