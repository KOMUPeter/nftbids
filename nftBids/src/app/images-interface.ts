export interface Nft {

    id: number;
    nftName: string;
    nftCreationDate: Date;
    initialPrice: number;
    isAvailable: boolean;
    actualPrice: number;
    nftFlow: number;
    categories: any[]; 
    nftImage: nftImages[],
    
}

export interface nftImages {
    id: number;
    path: string;
    nftImage: string;
    updatedAt: Date;

}

export interface nftOwner {
    name: string;
}
